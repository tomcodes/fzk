import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
import frazalakons from './frazalakons'
/**
* @see routes/web.php:178
* @route '/admin/pending'
*/
export const pending = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: pending.url(options),
    method: 'get',
})

pending.definition = {
    methods: ["get","head"],
    url: '/admin/pending',
} satisfies RouteDefinition<["get","head"]>

/**
* @see routes/web.php:178
* @route '/admin/pending'
*/
pending.url = (options?: RouteQueryOptions) => {
    return pending.definition.url + queryParams(options)
}

/**
* @see routes/web.php:178
* @route '/admin/pending'
*/
pending.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: pending.url(options),
    method: 'get',
})

/**
* @see routes/web.php:178
* @route '/admin/pending'
*/
pending.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: pending.url(options),
    method: 'head',
})

/**
* @see routes/web.php:178
* @route '/admin/pending'
*/
const pendingForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: pending.url(options),
    method: 'get',
})

/**
* @see routes/web.php:178
* @route '/admin/pending'
*/
pendingForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: pending.url(options),
    method: 'get',
})

/**
* @see routes/web.php:178
* @route '/admin/pending'
*/
pendingForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: pending.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

pending.form = pendingForm

const admin = {
    pending: Object.assign(pending, pending),
    frazalakons: Object.assign(frazalakons, frazalakons),
}

export default admin